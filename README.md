# twitter-cient
A small client to call Twitter API

Instructions : Your challenge is to create a single website in PHP (Choose the framework you are most best with) which will fetch the Twitter API for the latest 200 tweets related to Taste.com.au.
That includes the use of #hashtags, mentions of @taste_team. You should also create a text search box to allow users to search the tweet by free text.
Your code should contain a Readme file explaining how to install and run the unit & functional tests. You don't need to make the UI look very pretty.

## How to run : 
1. Git clone the repository
2. cd to the application directory and run 'composer install'
3. To run the application - Easy way

    (a) Check permissions for the cake server. If it's not executable run 'chmod +x bin/cake'
    
    (b) Run Cake's in built web server 'bin/cake server -p 8765'
    
    (3) Go to 'http://localhost:8765/twitter/get-tweets'
    
4. To run the application - Cool way

    (a) cd to the 'docker-scripts' directory
    
    (d) run 'docker-compose up --build'
    
    (3) Make a cup of coffee
    
    (4) Go to 'http://localhost/twitter/get-tweets'
    
## Shortcuts
1. I did not write *All* the unit tests. I just wrote the main ones.  
