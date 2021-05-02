Veriler için çalıştırılması gereken komut

`php artisan db:seed`

Şirketler verisi için çalıştırılması gereken komut

`php artisan db:seed --class=CompaniesSeeder`


###API rotaları şu şekildedir.

- /api/companies [POST] 
	- Content-Type: application/json
	- `{
		"site_url": "akincankoc.com",
		"name": "Akın Can",
		"lastname": "Koç",
		"companyname": "kobisi",
		"email": "akincankoc@gmail.com",
		"password": "demo" }`
		
- /api/companypackages [POST]
	- Content-Type: application/json
	- `{
		"company_id": 1,
		"package_id": 1,
		"period": "monthly"
		}`
		
- /api/company/check-company-package
	- Content-Type: application/json
	- `{
		"token": "QWvEsW4gQ2FuOktvw6c=-701b447b-9d7d-420a-ab5f-ab71a9f0dcca"
		}`
