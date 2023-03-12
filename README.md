## Simple TODO php list

ToDo list web application that implements the MVC model using pure PHP.

Tasks consist of:
- username;
- e-mail;
- task text;

Start page - a list of tasks for 6 pieces with the ability to sort by username, email and status. Any visitor without authorization can see the list of tasks and create new ones.

Administrator page (login "admin", password "123"). The administrator has the ability to edit all fields of the task and mark task as completed. Completed tasks in the general list are displayed with a corresponding mark. If task was changed on admin page, it also will display with a corresponding mark.

## Requirements

PHP >= 8.0.13

MYSQL >= 8.0.26

Composer >= 2.3.7
