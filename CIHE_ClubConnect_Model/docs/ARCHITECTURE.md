# System Design

## Architecture

```text
Browser / Client
HTML + CSS + JavaScript
        |
        v
PHP 8+ Application
Sessions | RBAC | Validation | CRUD | Smart Help
        |
        v
PDO Prepared Statements
        |
        v
MySQL Database
Users | Events | Announcements | Activity Logs
```

## ERD

```text
USERS
 id PK
 name
 email UNIQUE
 password_hash
 role
 active
 created_at
   |1
   |------< EVENTS
   |        id PK
   |        created_by FK
   |        updated_by FK
   |
   |------< ANNOUNCEMENTS
   |        id PK
   |        created_by FK
   |        updated_by FK
   |
   |------< ACTIVITY_LOGS
            id PK
            user_id FK
```

The model keeps authentication data, events, announcements and audit history in separate tables. Foreign keys preserve relationships, while indexes support event date/category/title access patterns.
