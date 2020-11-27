#demonstration 
import os
import codecs
import re #regular expression
import smtplib
from tkinter import *
from tkinter import messagebox

window = Tk()
window.withdraw() #removes the Tk window

#file handler - that has session
#with codecs.open(r"C:\Users\noi40\OneDrive\Documents\GitHub\ITFN4154\WP\functions.php", encoding="utf-8", errors="ignore") as myfile:

#file handler - that does not have session
with codecs.open(r"C:\Users\noi40\OneDrive\Documents\GitHub\datatable\source\ajax.php", encoding="utf-8", errors="ignore") as myfile:
   content = myfile.read() #read file

pattern = re.compile(r'session[A-Za-zÀ-ȕ0-9(),-_.,]\w*')
#pattern = re.compile(r'session_[a-z]\w*') #scanning for 'session'

if pattern.search(content):
   print('match found')
else:
   #2 types of alert: messagebox and email 
   messagebox.showwarning('Security Alert', 'Session Funtion undetected. Possible issues, please review.')
   EMAIL_ADDRESS = ""
   EMAIL_PASSWORD = ""

   with smtplib.SMTP('smtp.gmail.com', 587) as smtp:
      smtp.ehlo()
      smtp.starttls()
      smtp.ehlo()
    
      smtp.login(EMAIL_ADDRESS, EMAIL_PASSWORD)
    
      subject = 'Alert'
      body = 'Session Function undetected! Please review.'
    
      msg = f'Subject: {subject}\n\n{body}'
    
      smtp.sendmail(EMAIL_ADDRESS, 'ohouangvan@student.clayton.edu', msg)

