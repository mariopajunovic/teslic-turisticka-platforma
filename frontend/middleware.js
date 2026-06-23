/* global process */
import { next } from '@vercel/edge'

// Vercel Edge Middleware — Basic Auth zaštita cijelog preview deploya.
// Vraća 401 PRIJE nego se išta učita (prava zaštita + nije indeksabilno).
// Kredencijali se postavljaju kao Environment Variables na Vercelu:
//   BASIC_AUTH_USER, BASIC_AUTH_PASSWORD
export const config = {
  // Štiti sve osim favicona i robots.txt (Vercel interne rute su izuzete automatski).
  matcher: ['/((?!favicon.ico|robots.txt).*)'],
}

export default function middleware(request) {
  const USER = process.env.BASIC_AUTH_USER || 'teslic'
  const PASS = process.env.BASIC_AUTH_PASSWORD || 'teslic2026'

  const header = request.headers.get('authorization') || ''
  const [scheme, encoded] = header.split(' ')

  if (scheme === 'Basic' && encoded) {
    const [user, pass] = atob(encoded).split(':')
    if (user === USER && pass === PASS) {
      return next()
    }
  }

  return new Response('Potrebna prijava za pristup.', {
    status: 401,
    headers: {
      'WWW-Authenticate': 'Basic realm="TO Teslic - privatni pregled", charset="UTF-8"',
      'X-Robots-Tag': 'noindex, nofollow',
    },
  })
}
