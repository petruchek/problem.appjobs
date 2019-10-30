Job Matching

Original problem statement:

Imagine you have a bike and a driving license. You also found a job board with a list of companies offering a job. 
To get the job, you need to fulfill some requirements. 
There are 10.000 companies on the job board, 10 examples are as follows:

* "Company A" requires an apartment or house, and property insurance.
* "Company B" requires 5 door car or 4 door car, and a driver's license and car insurance.
* "Company C" requires a social security number and a work permit.
* "Company D" requires an apartment or a flat or a house.
* "Company E" requires a driver's license and a 2 door car or a 3 door car or a 4 door car or a 5 door car.
* "Company F" requires a scooter or a bike, or a motorcycle and a driver's license and motorcycle insurance.
* "Company G" requires a massage qualification certificate and a liability insurance.
* "Company H" requires a storage place or a garage.
* "Company J" doesn't require anything, you can come and start working immediately.
* "Company K" requires a PayPal account.

How to run: php run.php <input.txt

To do:
	- validate input
	- handle invalid input
	- implement proper parser in meet_requirements() and stop using eval()
	- accept applicant's assets as a string (currentlly array accepted)

Refactoring required: the most expensive part of this solution is parsing textual requirements into some structure computer can work with.
Since any real world task will require multiple searches against more or less same list of vacancies, it makes sense to parse once 
and store the parsed structure for faster checks in the future.

Author: Val Petruchek <petruchek@gmail.com> #http://zliypes.com.ua/

