#!/usr/bin/python

from jenkinsapi.jenkins import Jenkins
import subprocess as sub
from pkg_resources import resource_string
import sys
import MySQLdb

# Fetching the GITHUB API Details


#Replace DB_USER && DB_PASSWORD 
#with your MySQL DB Username and Password Respectively
db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                     user=DB_USER,         # your username
                     passwd=DB_PASSWORD,  # your password
                     db="classicmodels")        # name of the data base

# Creating a Cursor object to perform the execution of SQL queries.
cur = db.cursor()

#Use fetchall() method to fetch multiple rows and store the result in a list variable. 

#Selecting the Git Hub Repo
cur.execute("SELECT classicmodels.api_information.github_repository FROM classicmodels.api_information WHERE api_name='GITHUB'")
data = cur.fetchall()
GITHUB_REPO=str(data[0])

#Selecting The GitHub User
cur.execute("SELECT classicmodels.api_information.github_username FROM classicmodels.api_information WHERE api_name='GITHUB'")
data = cur.fetchall()
GITHUB_USER_NAME=str(data[0])

#Selecting The GitHub API Key/ Password
cur.execute("SELECT classicmodels.api_information.github_api_key FROM classicmodels.api_information WHERE api_name='GITHUB'")
data = cur.fetchall()
GITHUB_API_KEY=str(data[0])
#disconnect from the DB
db.close()

#Replace JENKINS_SERVER_USERNAME && JENKINS_SERVER_PASSWORD
#with the Jenkins Server Admin Username && Password Respectively

JENKINS_SERVER_URL = 'http://localhost:8080'
JENKINS_SERVER_USERNAME = '' #To be filled
JENKINS_SERVER_PASSWORD = '' #To be filled
INITIALMD5HASH = '1e1d0f6428a89814e811802fd8537f3d'

#Computing the MD5 Hash of hello.py
#To check if it has been modified  
while(1):
  p=sub.Popen(['md5sum','/home/pr3dator/pr3dator_web_manager/jenkinstestbuild/hello.py'],stdout=sub.PIPE,stderr=sub.PIPE)
  output, errors = p.communicate()
  UPDATEMD5HASH=output.split()[0]
  if (UPDATEMD5HASH != INITIALMD5HASH ):
      print ("MD5 Hash For Hello.py has changed , Jenkins Job Triggered")
      # Trigger the jenkins job if the hash has changed
      J=Jenkins(JENKINS_SERVER_URL, username = JENKINS_SERVER_USERNAME, password = JENKINS_SERVER_PASSWORD)
      print ("Jenkins Server Version:" + str(J.version) )
      job=J.get_job('test-job')
      print ("Is Jenkins Job Enabled:" + " " + str(job.is_enabled()))
      print ("Is Jenkins JOB Running already:" + " " +  str(job.is_running()))
      #Feeding a sampple xml configuration file
      #required for the jenkins job
      xml = resource_string('examples', 'addjob.xml') 
      #This XML config file is used by the create_job api
      #To create the jenkins job title 'test-job'
      job = J.create_job(jobname='test-job', xml='addjob.xml')
      #Invoking the 'test-job' jenkins job
      job.invoke()
      print ("Jenkins Job Triggered")
      sys.exit(0)
 
  else :
       print ("hello.py has not been modified")
       print ("Jenkins Job Not Triggered ")
       print ("Exiting.....")
       sys.exit(0)		
			
#If you are curious , Additional API calls follow 			
# Jenkins objects appear to be dict-like, mapping keys (job-names) to their attributes
#print J['test-job'] -> To obtain the attributes of jenkins job titled "jenkins-job"
#print J['test_job'].get_last_good_build() -> Ex: To obtain the last successfull build 
#jobs=J.get_jobs() -> To Obtain the list of jenkin's jobs
#print(xml) -> To Print the XML configuration file leveraged by the jenkins job

