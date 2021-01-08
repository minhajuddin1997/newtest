# Deployment Guide  
- Go to GitBash clone the project from this link.   
  >https://github.com/amirali2019/service_market  
  
- Rename the **.env.example file** to **.env** file and create database and import the file **service_market.sql** and enter this DB name to .env file.  
  
- Run the Artisan command in order to clear a cache.                        
   >**php artisan config:cache**.  
  
- We use Vue client-side routing, in order to change the component routes, you should go to this directory  
  >**Directory\service_market\resources\js\helpers\routes\routePrefixPath.js**.  
  
- Run your project, by opening cmd and executing **Artisan** command      
    >**php artisan serve**  
  
	 and in order to compile the latest **JavaScript** files open another cmd window and run this command  
   >**npm run watch**   
      
    and type project **URL** in the browser with the path you have set in **Step 4**.
# newtest
