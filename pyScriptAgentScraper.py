from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import os
import gc
import time
import json
import sys

license = sys.argv[1]
name = ""
licIssued = ""
expirationDate = ""


driver = webdriver.PhantomJS('/usr/bin/phantomjs')

driver.get("http://www2.dre.ca.gov/PublicASP/pplinfo.asp")
driver.find_element_by_name('LICENSE_ID').send_keys(license)

driver.find_element_by_xpath('//*[@id="main_content"]/div/form/table/tbody/tr[6]/td[2]/input[1]').click()


name = driver.find_element_by_xpath('/html/body/table/tbody/tr[2]/td[2]/font')
licIssued = driver.find_element_by_xpath('/html/body/table/tbody/tr[8]/td[2]/font')
expirationDate = driver.find_element_by_xpath('/html/body/table/tbody/tr[5]/td[2]/font')





D = {"name":name.text, "lic": licIssued.text, "expirationDate": expirationDate.text}

print json.dumps(D)

driver.quit()