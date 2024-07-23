# test_thrive_cart

I used the base of a simple PHP test as I don't have many dev tools installed on my personal computer since my last format 

"php.exe .\Main.php" is enough to launch the UNIT_TESTING called by the Main class

_ To keep the test simple and readable I use separated object implementing small interfaces to initiate the catalogues and 
	 delivery rules with hard coded values;
	(In my last position as Backend PHP we would have use a database via symphony and Doctrine to get those kind of values and be able to change
	 them without deployment of the solution, creating entities from the results of for example 
	 a "select * from widget" on line of the result been 1 object;)
	
 Depending of the flexibility we want, It could be also stored in XMLs files, environmental variables or even,if it never moves, a hardcoded array of
	 key/values like the one I initiate as widgetList; 
  
_ For the widget, that could be added more easely than rules or offers, I use a loop to initiate the List of widget existing 


Assumptions :
_ Everything is in dollars no need to manage the currency
_ The delivery cost doesn't change with the amount of widget bought, more weight or volume usually do increase the cost;
_ When calculating the total, we also want to display the detail before/after offers and delivery costs (every website using basket I know)
_ I assume special offers can be stacked, foreach pair of RedWidget the reduction applies (I left in comment what would be the calculation if not)
_ For the moment we don't want to add a startingDate and expireDate on the offer 
_ Along the function "add", I added "remove" and "adaptQuantity";
