/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        "./resources/**/*.{html,js}",
        './resources/**/*.blade.php',
        './resources/views/*.blade.php',
        './resources/views/forms/components*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/filament/resources/**/*.blade.php',
        './vendor/ralphjsmit/laravel-filament-onboard/resources/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                danger : {  DEFAULT: '#E74C3C',  50: '#FBE2DF',  100: '#F9D1CD',  200: '#F4B0A9',  300: '#F08F85',  400: '#EB6D60',  500: '#E74C3C',  600: '#D12B1A',  700: '#9F2114',  800: '#6D160D',  900: '#3B0C07'},
                primary: {  DEFAULT: '#0F4E96',  50: '#6CAAF0',  100: '#5A9FEE',  200: '#358AEB',  300: '#1675E0',  400: '#1361BB',  500: '#0F4E96',  600: '#0A3363',  700: '#051930',  800: '#000000',  900: '#000000'},
                info   : {  DEFAULT: '#3993CE',  50: '#CCE3F2',  100: '#BCDAEE',  200: '#9BC9E6',  300: '#7AB7DE',  400: '#5AA5D6',  500: '#3993CE',  600: '#2974A6',  700: '#1E5579',  800: '#13354C',  900: '#08161F'},
                success: {  DEFAULT: '#10B981',  50: '#8CF5D2',  100: '#79F3CB',  200: '#53F0BC',  300: '#2EEDAE',  400: '#13DF9B',  500: '#10B981',  600: '#0C855D',  700: '#075239',  800: '#031E15',  900: '#000000'},
                warning: {  DEFAULT: '#F59E0B',  50: '#FCE4BB',  100: '#FBDCA8',  200: '#FACD81',  300: '#F8BD59',  400: '#F7AE32',  500: '#F59E0B',  600: '#C07C08',  700: '#8A5906',  800: '#543603',  900: '#1E1401'},
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
