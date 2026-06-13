# PROJECT OVERVIEW

## 1. PROJECT SUMMARY
- SmartKids is a Laravel + MySQL web platform for managing kindergartens.
- Roles: Admin, Educator, Parent (3 dashboards)
- Stack: Laravel (backend), MySQL (DB), TailwindCSS (frontend), DomPDF/TCPDF (PDF), Firebase or WebSockets (real-time)

## 2. MODULE MAP
- **Children Management**: enrollment, attendance, class assignment
- **Teacher Management**: profiles, class attribution
- **Enrollment Management**: forms, waitlists, PDF dossiers
- **Payments**: tracking, auto-reminders, PDF receipts
- **Activities**: planning, child enrollment, parent reports
- **Meals**: weekly menus, parent visibility
- **Parent Portal**: child tracking, payment history
- **Communication System**: push notifications, alerts

## 3. ROLE PERMISSIONS TABLE

| Module | Admin | Educator | Parent |
| :--- | :--- | :--- | :--- |
| **Children Management** | Read / Write | Read / Edit (Attendance) | Read (Own Child) |
| **Teacher Management** | Read / Write | Read (Own Profile) | No Access |
| **Enrollment Management** | Read / Write | No Access | Read / Write (Submit Forms) |
| **Payments** | Read / Write | No Access | Read (Own History) |
| **Activities** | Read / Write | Read / Write (Own Class) | Read (Own Child Reports) |
| **Meals** | Read / Write | Read | Read |
| **Parent Portal** | No Access | No Access | Read / Write |
| **Communication System** | Read / Write | Read / Write (Own Class) | Read |

## 4. KEY CONSTRAINTS
- All PDF generation via DomPDF
- Real-time via Firebase Cloud Messaging or Laravel WebSockets
- Responsive design (mobile-first, TailwindCSS)
- French language UI (platform is Tunisian, French-speaking)

## 5. CODING CONVENTIONS
- RESTful API routes (`api/v1/...`)
- Service-Repository pattern for business logic
- Form Requests for validation
- Policies + Gates for authorization
- Blade templates for frontend (no SPA)
