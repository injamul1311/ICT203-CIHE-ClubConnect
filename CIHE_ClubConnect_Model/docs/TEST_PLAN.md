# Test Plan and Evidence Sheet

Run these tests against the installed application. Capture screenshots/logs in the Evidence column when using the model for demonstration.

| ID | Test | Type | Expected result | Evidence |
|---|---|---|---|---|
| T01 | Login with Admin demo account | Positive | Dashboard loads and Admin controls are visible | Capture |
| T02 | Login with wrong password | Negative | Generic error; no authenticated session | Capture |
| T03 | Standard User opens `/events/create.php` | Negative | HTTP 403 / access denied | Capture |
| T04 | Admin creates valid event | Positive | Record saved and audit entry created | Capture |
| T05 | Create event with blank title | Negative | Validation blocks save | Capture |
| T06 | Admin edits event | Positive | Changes persist and updated timestamp/user changes | Capture |
| T07 | Admin deletes event | Positive | Record removed through POST + CSRF | Capture |
| T08 | Search event title/location | Positive | Matching records only | Capture |
| T09 | Filter by category | Positive | Only selected category appears | Capture |
| T10 | Pagination with >6 events | Positive | Page links split dataset correctly | Capture |
| T11 | Login SQL-injection-like text | Negative | Authentication fails; DB remains safe | Capture |
| T12 | HTML/script-like text in content | Negative | Output is escaped, not executed | Capture |
| T13 | Smart Help known keyword | Positive | Relevant predefined response appears | Capture |
| T14 | Smart Help unknown question | Negative | Safe fallback is returned | Capture |
| T15 | Mobile-width navigation | Positive | Toggle navigation and content remain usable | Capture |
| T16 | Delete with missing/invalid CSRF | Negative | Request rejected | Capture |
| T17 | Announcement create/edit/delete | Positive | Full second CRUD module works | Capture |
| T18 | Audit log as Admin | Positive | Recent actions show user/action/time | Capture |

## Evidence guidance
Use real screenshots or logs after running the application. Do not label a test “passed” until it has actually been executed.
