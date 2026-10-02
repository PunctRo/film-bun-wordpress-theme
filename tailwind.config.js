/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './template-parts/**/*.php',
        './includes/**/*.php',
        './*.php',
        './assets/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                'prussian-blue-3': '#002945',
            },
            backgroundColor: {
                'prussian-blue-3': '#002945',
            },
        },
    },
    safelist: [
        'group',
        'group-hover:opacity-100',
        'group-hover:visible',
        'group-hover:rotate-180',
        'group-hover:scale-100',
        'opacity-0',
        'invisible',
        'scale-95',
        'bg-prussian-blue-3/95',
        'hover:bg-cyan-400/10',
        'hover:bg-white/5',
        'hover:text-cyan-300',
        'hover:text-white',
        'w-56',
        'w-64',
        'text-[#f2f2f2]/90',
        'border-cyan-400/20',
        'backdrop-blur-md',
        'gap-5',
        'gap-6',
        'scrollbar-hide',
    ],
    // Prevent Tailwind from compiling WordPress image size classes (size-full, size-large, etc.)
    // These are semantic WP editor classes — Tailwind's size-* utilities would break content images.
    blocklist: [
        'size-full',
        'size-large',
        'size-medium',
        'size-thumbnail',
        'attachment-full',
        'attachment-large',
        'attachment-medium',
        'attachment-thumbnail',
    ],
    plugins: [
        // Plugin to hide scrollbars
        function({ addUtilities }) {
            const newUtilities = {
                '.scrollbar-hide': {
                    '-ms-overflow-style': 'none',
                    'scrollbar-width': 'none',
                    '-webkit-overflow-scrolling': 'touch',
                    '&::-webkit-scrollbar': {
                        display: 'none',
                    },
                },
            };
            addUtilities(newUtilities);
        }
    ],
};
