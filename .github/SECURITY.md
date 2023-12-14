# Security Tips
1- Make sure to enable captcha. It is an important thing to prevent bot attacks on your site.

2- If the site and server are both on the same server, use two separate database accounts to connect the host to the server. One account that only has access to the auth, characters and world databases and only has permission to access SELECT, DELETE, INSERT and UPDATE queries.
also if the site is on another host, they only need to enter the IP address in host section, but many people put *, which makes every ip able to connect to database otherwise enter localhost.

![Screenshot 2023-12-14 121152](https://github.com/FusionWowCMS/FusionCMS/assets/12217476/e6379669-ba1c-4453-9594-d4d567293a00)


3- We also need another account for the website database that only has access to that database and we can and should give it permission to access the queries in the image below:

![Screenshot 2023-12-14 121153](https://github.com/FusionWowCMS/FusionCMS/assets/12217476/4e962983-8f71-4db8-b0b9-20c1faed6f20)

4- Use strong passwords to create the database and do not give these passwords to anyone.

5- Do not allow anyone access to your website files or access to your host because he can access the file or database where the information of all databases is stored.

6- Create a separate account from owner account with a strong password for console account of each realm.

7- Force GM accounts except Console Account to use Two-step login.

# Security Policy
We attach great importance to the security of our users data, but we are humans and not infallible.
That's why we rely on you, the open source contributors, to inform us about actual and possible security vulnerabilities.
Please follow the guideline below to get in touch with us, even if you're not sure, if your issue is regarding the data security.

## Reporting a Vulnerability
**Please do not open GitHub issues for security vulnerabilities, as GitHub issues are publicly accessible!**

Instead, contact us per Discord [Nightprince](https://discordapp.com/users/408541006238187530) or join our Discord server [https://discord.gg/5nSt9puU4V](https://discord.gg/tnWTkZ7akZ).
We guarantee a response within two workdays and a security patch as fast as possible.

Thanks for your cooperation and your understanding.
