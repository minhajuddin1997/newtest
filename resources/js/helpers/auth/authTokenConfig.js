const authApiConfig=(token)=>{
    return  {
        headers: {
            Authorization: 'Bearer ' + token,
                Accept: 'application/json'
        }
    };
};

export {authApiConfig}
