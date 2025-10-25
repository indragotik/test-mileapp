import type { Config } from 'tailwindcss'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

const config: Config = {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}', // pastikan Vue files ikut discan
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#2563eb', // biru utama (Tailwind blue-600)
          light: '#3b82f6',
          dark: '#1e40af',
        },
        secondary: {
          DEFAULT: '#6366f1', // indigo
          light: '#818cf8',
          dark: '#4338ca',
        },
        accent: '#f97316', // oranye lembut
      },
      backdropBlur: {
        xs: '2px',
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic':
          'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
      },
      boxShadow: {
        soft: '0 4px 20px rgba(0, 0, 0, 0.06)',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
  plugins: [
    forms,
    typography,
  ],
},
},
}
export default config