# fraudsilo
Multi-database Fraud Protection for WHMCS

## What Does FraudSilo Do?
FraudSilo allows you to screen new orders against multiple fraud databases at the same time. 
At the moment, we support:
* [FraudLabs Pro](http://www.fraudlabspro.com/?ref=20215) - Free plan available for up to 500 orders per month
* [FraudRecord](https://www.fraudrecord.com/) - Hosting industry database of bad actors
* [Kickbox](https://kickbox.com) - Check for temporary and dispoable emails, plus email deliverability

## Install Instructions
1. Create a folder named /modules/fraud/fraudsilo/ in your WHMCS Installation
2. Upload the fraudsilo.php into that folder
3. In WHMCS, navigate to: System Settings > Fraud Protection > click Activate under FraudSilo. 

## Configuration
* Enable the services that you wish to use (FraudLabs Pro, FraudRecord and Kickbox).
* Enter your API keys
* Set your thresholds for which orders will be flagged as Fraud (eg disposable emails, free emails, proxy/VPN IPs, fraud score thresholds)

## Fair Use Notice
This project is licensed under the GPLv3. Redistribution, commercial usage, and modifications are allowed *only if* the full source code is made available under the same license. Rebranding or reselling without significant contribution is strongly discouraged.
