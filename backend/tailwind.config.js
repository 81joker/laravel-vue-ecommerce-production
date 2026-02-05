  // tailwind.config.js
  module.exports = {
    purge: [],
    purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
     darkMode: false, // or 'media' or 'class'
     theme: {
       extend: {
        keyframes: {
          fadeInDown: {
            '0%': {
              opacity: 0,
              transform: 'translateY(-0.75rem)',
            },
            '100%': {
              opacity: 1,
              transform: 'translateY(0rem)',
            },
          },
        },
        animation: {
          'fade-in-down': 'fadeInDown 0.2s ease-in-out both',
        },
       },
     },
     variants: {
       extend: {},
     },
     plugins: [],
   }