# UML Diagram Generation Guide

This document defines exactly how all UML diagrams for the SmartKids project report should be generated using PlantUML syntax.

## 1. USE CASE DIAGRAM

**Purpose:** Demonstrates all actors and their interactions with the system modules.
**Report Chapter:** Requirements Analysis / Specification.

```plantuml
@startuml
left to right direction
skinparam packageStyle rectangle

actor Admin
actor Educateur
actor Parent
actor System << Automated >>

package "SmartKids Platform" {
  usecase "Manage Users & Classes" as UC_Admin1
  usecase "Validate Enrollments" as UC_Admin2
  usecase "Manage Payments" as UC_Admin3
  
  usecase "Take Attendance" as UC_Ed1
  usecase "Plan Activities" as UC_Ed2
  usecase "Message Parents" as UC_Ed3
  
  usecase "Submit Enrollment" as UC_Par1
  usecase "View Child History" as UC_Par2
  usecase "View Receipts" as UC_Par3
  
  usecase "Auto-Send Reminders" as UC_Sys1
  usecase "Real-Time Broadcast" as UC_Sys2
  usecase "Generate PDF" as UC_Sys3

  Admin --> UC_Admin1
  Admin --> UC_Admin2
  Admin --> UC_Admin3
  
  Educateur --> UC_Ed1
  Educateur --> UC_Ed2
  Educateur --> UC_Ed3
  
  Parent --> UC_Par1
  Parent --> UC_Par2
  Parent --> UC_Par3

  System --> UC_Sys1
  
  UC_Admin2 ..> UC_Sys3 : <<extend>>
  UC_Admin3 ..> UC_Sys3 : <<extend>>
  UC_Sys1 ..> UC_Sys2 : <<include>>
}
@enduml
```

## 2. CLASS DIAGRAM

**Purpose:** Visualizes the domain model, 11 entities, and their relationships.
**Report Chapter:** System Architecture / Database Design.

```plantuml
@startuml
package "Domain Layer" {
  
  class User {
    + id : int
    + name : string
    + role : string
    + auth()
  }

  class ClassRoom {
    + id : int
    + name : string
    + capacity : int
    + assignEducator()
  }

  class Child {
    + id : int
    + first_name : string
    + last_name : string
    + allergies : string
    + getHistory()
  }

  class Enrollment {
    + status : string
    + submit()
  }

  class Attendance {
    + date : date
    + status : string
    + mark()
  }

  class Payment {
    + amount : double
    + status : string
    + issueReceipt()
  }

  class Activity {
    + name : string
    + date : datetime
  }

  class ActivityChild {
    + attended : boolean
  }

  class Meal {
    + week_start : date
    + menus : JSON
  }

  class Notification {
    + type : string
    + data : JSON
    + read_at : datetime
  }

  class Message {
    + body : text
    + read_at : datetime
  }

  User "1" -- "*" ClassRoom : educator >
  User "1" -- "*" Child : parent >
  ClassRoom "1" -- "*" Child : contains >
  Child "1" -- "1" Enrollment : owns >
  Child "1" -- "*" Attendance : logs >
  Child "1" -- "*" Payment : incurs >
  Child "*" -- "*" Activity : participates (ActivityChild) >
  ClassRoom "1" -- "*" Meal : receives >
  User "1" -- "*" Notification : receives >
  User "1" -- "*" Message : sends/receives >

}
@enduml
```

## 3. SEQUENCE DIAGRAMS

**Report Chapter:** System Design / Dynamic Modeling.

### A. Child Enrollment Flow
**Purpose:** Parent submission to admin validation.
```plantuml
@startuml
actor Parent
participant UI
participant Server
database Database
participant PDF_Engine

Parent -> UI: Submit Enrollment Form
UI -> Server: POST /enrollments
Server -> Database: Save Status = 'pending'
Server --> UI: Confirmation
Admin -> Server: Validate Application
Server -> Database: Update Status = 'active', Assign Class
Server -> PDF_Engine: Generate Dossier PDF
Server -> Database: Save File Path
Server --> Admin: Success
@enduml
```

### B. Payment Recording Flow
**Purpose:** Tracking payment and generation of DomPDF receipt.
```plantuml
@startuml
actor Admin
participant PaymentService as Service
database DB
participant DomPDF
participant Storage

Admin -> Service: markAsPaid(payment_id)
Service -> DB: UPDATE status='paid', paid_at=now()
Service -> DomPDF: loadView('receipt.blade.php')
DomPDF -> Service: Stream output bytes
Service -> Storage: disk('public')->put('receipt.pdf')
Service -> DB: UPDATE receipt_path
Service --> Admin: Return Success notification
@enduml
```

### C. Attendance & Absence Notification Flow
**Purpose:** Taking database attendance and triggering WebSocket events.
```plantuml
@startuml
actor Educateur
participant Controller
participant DB
participant Events
participant WebSocket

Educateur -> Controller: markAttendance(children_array)
Controller -> DB: Insert Attendance Records
opt If child marked 'absent'
  Controller -> Events: dispatch(AbsenceRecorded)
  Events -> DB: Save Notification
  Events -> WebSocket: Broadcast to private-user.{parent_id}
  WebSocket -> Parent_Browser: Echo.js triggers Toast
end
Controller --> Educateur: Done
@enduml
```

### D. Real-Time Notification Broadcast Flow
**Purpose:** Event passing through Laravel WebSockets to Echo UI.
```plantuml
@startuml
participant Laravel_Event as Event
participant Laravel_WebSockets as WS_Server
participant Echo_JS_Client as Echo
participant Browser_UI as UI

Event -> WS_Server: Post Payload (pusher-api)
WS_Server -> Echo: Push message over TCP/WSS Socket
Echo -> UI: .listen() Callback triggers
UI -> UI: Display Badge/Toast
@enduml
```

## 4. ACTIVITY DIAGRAM

**Purpose:** Shows the complex conditional enrollment workflow process.
**Report Chapter:** Functional Requirements / Workflows.

```plantuml
@startuml
start
:Parent submits application;
:Admin reviews documents;
if (Documents Valid?) then (Yes)
  :Change Status to 'Pending Approval';
  if (Class Space Available?) then (Yes)
    :Assign to Class;
    :Set Status = 'Active';
    :Generate PDF Dossier;
    :Send Welcome Notification;
  else (No)
    :Set Status = 'Waitlist';
    :Notify Parent;
  endif
else (No)
  :Request Missing Documents;
endif
stop
@enduml
```

## 5. DEPLOYMENT DIAGRAM

**Purpose:** Illustrates the physical XAMPP-based architecture.
**Report Chapter:** System Deployment / Physical Architecture.

```plantuml
@startuml
node "Client Browser" as Client {
  component "Echo.js (Sockets)"
  component "Blade HTML"
}

node "XAMPP Server Environment" as Server {
  agent "Apache HTTP" as Apache
  
  component "Laravel App (PHP 8+)" as Laravel {
    component "Controllers/Services"
  }
  
  component "Laravel WebSockets (Port 6001)" as WS
  
  database "MySQL 8 database" as MySQL
  
  storage "Storage Disk (PDFs)" as Disk
}

Client -- Apache : HTTP/HTTPS
Client -- WS : WebSocket (WS/WSS)
Apache -- Laravel : mod_php / FastCGI
Laravel -- MySQL : PDO / Eloquent
Laravel -- Disk : Local File System
Laravel -- WS : Internal cURL / Broadcasting
@enduml
```
