function companyFieldsToggle(status){
    let $onlyCompany = document.querySelectorAll('.only-company');
    let $onlyCompanyInputs = document.querySelectorAll('.only-company input');
    if(status){
        $onlyCompany.forEach(element => {
            element.classList.remove('d-none');
        });
        $onlyCompanyInputs.forEach(element => {
            element.required = true;
        });
    }else{
        $onlyCompany.forEach(element => {
            element.classList.add('d-none');
        });
        $onlyCompanyInputs.forEach(element => {
            element.required = false;
        });
    }
}

let $companyToggle = document.querySelector('#is_company');
if($companyToggle){
    companyFieldsToggle($companyToggle.checked);
    $companyToggle.addEventListener('change', event => {
        companyFieldsToggle(event.target.checked);
    });
}