# cs3600-habits
Habit tracker website for CS3600 Lab


habits page will be the main web application page. It should only be accessible if the user has logged in... Maybe accessible for anyone, but just tells them that they have to log in if they aren't. The main habits application will feature tabs (https://www.w3schools.com/howto/howto_js_tabs.asp). Tasks can be either repetetive or one time. The tabs will be "Daily","Weekly","Monthly","Yearly", and "One Time". Each tab will show which tasks the user has completed for that time period, and will also feature a countdown until the period ends. For example, the daily tab will show a countdown until the next day starts. When the user completes a task, they can click a button next to it to indicate that it is done. For each completed task, the user will receive a point equal to the number of days in the time frame (daily is 1, weekly 7, monthly 30, and yearly 365). One time tasks will award 50 points. The current streak for completing all of the tasks in the tab will also be shown at the top. Failing to complete a task in the alloted time will result in a subtraction of its points and will reset the streak. Streaks may alternatively be on a per-task basis. 

The database tables will be:
* Some sort of table for login and user credentials
* Task table with a primary key of task id and user id. It will also show the task title, description, current streak, and time last completed.  
