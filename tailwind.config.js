/** @type {import('tailwindcss').Config} */
export default {
    mode: 'jit',
    darkMode: 'class',
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./public/**/*.js",
      './public/js/tinymce/skins/ui/oxide-dark/skin.css'
    ],
    theme: {
      extend: {},
    },
    plugins: []
  }


  
