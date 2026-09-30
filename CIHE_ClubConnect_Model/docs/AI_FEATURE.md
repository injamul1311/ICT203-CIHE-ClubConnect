# Intelligent / AI-Assisted Feature Appendix

## Feature
**Smart Help Assistant** — a local, rule-based assistant for common ClubConnect questions.

## How it works
1. The user submits a question.
2. PHP normalises it to lowercase.
3. Each curated rule contains keywords and one reviewed response.
4. The system counts keyword matches.
5. The response with the highest match score is displayed.
6. If no rule matches, a safe fallback is displayed.

## User value
The feature helps users understand events, announcements, login, Admin permissions, search and privacy without leaving the application.

## Responsible use
- The output is advisory.
- No record is created, edited, deleted or published automatically.
- The user chooses whether to follow the guidance.
- No personal/sensitive information is transmitted to a public AI service.
- The feature openly states that it is rule based.

## Limitations
- It cannot understand every phrasing or topic.
- Keywords can be ambiguous.
- Responses can become outdated if the application changes.
- It is not a replacement for a staff member or administrator.

## Mitigation
- Curated, narrow response scope.
- Safe fallback for unmatched questions.
- Central rule list that can be reviewed.
- Transparent explanation on the interface and in documentation.
