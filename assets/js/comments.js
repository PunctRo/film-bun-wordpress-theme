/**
 * Film Bun — Comments JS
 * Handles comment upvote/downvote with server-side dedup.
 * localStorage is used only as a UX cache (buttons stay disabled visually on reload).
 * The actual dedup is enforced server-side via IP hash + DB unique key.
 */

(function () {
    'use strict';

    var STORAGE_KEY = 'fbun_voted_comments';

    function getVotedMap() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
        } catch (_) {
            return {};
        }
    }

    function saveVotedMap(map) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(map));
        } catch (_) {
            // localStorage unavailable — silent fallback
        }
    }

    /**
     * Mark vote buttons for a given comment as voted.
     * @param {string|number} commentId
     * @param {string} votedType  'up' | 'down'
     */
    function disableVoteButtons(commentId, votedType) {
        var buttons = document.querySelectorAll(
            '.fbun-vote-btn[data-comment-id="' + commentId + '"]'
        );
        buttons.forEach(function (btn) {
            btn.classList.add('fbun-voted');
            btn.setAttribute('aria-disabled', 'true');
            if (btn.dataset.vote === votedType) {
                btn.classList.add('fbun-voted-active');
            }
        });
    }

    function updateCounts(commentId, up, down) {
        var wrap = document.querySelector(
            '.fbun-vote-btn[data-comment-id="' + commentId + '"]'
        );
        if (!wrap) return;
        var bar = wrap.closest('.fbun-vote-bar');
        if (!bar) return;

        var upCount   = bar.querySelector('.fbun-vote-up .fbun-vote-count');
        var downCount = bar.querySelector('.fbun-vote-down .fbun-vote-count');
        if (upCount)   upCount.textContent   = up;
        if (downCount) downCount.textContent = down;

        // Update aria-labels
        var upBtn   = bar.querySelector('.fbun-vote-up');
        var downBtn = bar.querySelector('.fbun-vote-down');
        if (upBtn)   upBtn.setAttribute('aria-label',   'Util (' + up + ' voturi)');
        if (downBtn) downBtn.setAttribute('aria-label', 'Neutil (' + down + ' voturi)');
    }

    function initVoteButtons() {
        var buttons = document.querySelectorAll('.fbun-vote-btn');
        if (!buttons.length) return;

        var voted = getVotedMap();

        // Restore voted state from localStorage (UX only — server is source of truth)
        buttons.forEach(function (btn) {
            var commentId = btn.dataset.commentId;
            if (voted[commentId]) {
                disableVoteButtons(commentId, voted[commentId]);
            }
        });

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                // Ignore if already voted (localStorage UX guard)
                if (btn.classList.contains('fbun-voted') || btn.classList.contains('fbun-loading')) {
                    return;
                }

                var config = window.FilmBunVote;
                if (!config || !config.nonce || !config.ajaxUrl) {
                    return;
                }

                var commentId = btn.dataset.commentId;
                var voteType  = btn.dataset.vote;

                btn.classList.add('fbun-loading');

                var body = new URLSearchParams({
                    action:     'vote_comment',
                    comment_id: commentId,
                    vote:       voteType,
                    nonce:      config.nonce,
                });

                fetch(config.ajaxUrl, {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body:    body.toString(),
                })
                .then(function (res) {
                    if (!res.ok && res.status !== 409) {
                        throw new Error('HTTP ' + res.status);
                    }
                    return res.json();
                })
                .then(function (data) {
                    btn.classList.remove('fbun-loading');

                    if (data.success) {
                        updateCounts(commentId, data.data.up, data.data.down);
                        // Save to localStorage and disable buttons
                        var map = getVotedMap();
                        map[commentId] = voteType;
                        saveVotedMap(map);
                        disableVoteButtons(commentId, voteType);

                    } else if (data.data && data.data.code === 'already_voted') {
                        // Server confirmed already voted (localStorage was cleared)
                        var map = getVotedMap();
                        map[commentId] = voteType;
                        saveVotedMap(map);
                        disableVoteButtons(commentId, voteType);
                    }
                    // Other errors (rate limit, etc.) — do nothing, button stays enabled
                })
                .catch(function () {
                    btn.classList.remove('fbun-loading');
                });
            });
        });
    }

    function initCommentForm() {
        var form = document.getElementById('fbun-commentform');
        if (!form) return;

        var requiredFields = [
            { id: 'author',  label: 'Numele tău' },
            { id: 'email',   label: 'Email' },
            { id: 'comment', label: 'Comentariul tău' },
        ];

        form.addEventListener('submit', function (e) {
            var firstInvalid = null;

            requiredFields.forEach(function (f) {
                var el = document.getElementById(f.id);
                if (!el) return;

                var errorId = 'fbun-error-' + f.id;
                var existing = document.getElementById(errorId);

                if (!el.value.trim()) {
                    e.preventDefault();

                    el.classList.add('fbun-field-error');

                    if (!existing) {
                        var msg = document.createElement('span');
                        msg.id        = errorId;
                        msg.className = 'fbun-error-msg';
                        msg.setAttribute('role', 'alert');
                        msg.textContent = f.label + ' este obligatoriu.';
                        el.parentNode.appendChild(msg);
                    }

                    if (!firstInvalid) firstInvalid = el;
                } else {
                    el.classList.remove('fbun-field-error');
                    if (existing) existing.remove();
                }
            });

            if (firstInvalid) firstInvalid.focus();
        });

        // Clear error on input
        requiredFields.forEach(function (f) {
            var el = document.getElementById(f.id);
            if (!el) return;
            el.addEventListener('input', function () {
                if (el.value.trim()) {
                    el.classList.remove('fbun-field-error');
                    var msg = document.getElementById('fbun-error-' + f.id);
                    if (msg) msg.remove();
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initVoteButtons();
            initCommentForm();
        });
    } else {
        initVoteButtons();
        initCommentForm();
    }
})();
