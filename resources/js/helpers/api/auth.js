const login=(email, password)=>{
    return new Promise((resolve, reject)=>{
        axios.post('/login', {email: email, password: password})
            .then(res=>res.data)
            .then((response) => {
                if(response[0]=="error"){
                    reject(response[1])
                }
                resolve(response[1]);
            })
            .catch((error) => {
                reject(error);
            });
    });
};

const logout=(email)=>{
    return new Promise((resolve, reject)=>{
        axios.post('/logout',{email:email})
            .then(res=>res.data)
            .then((res)=>{
                if(res=='1' || res==1){
                    resolve(1);
                }
                reject('error');
            }).catch((error)=>{
                reject(error);
        })
    });

};

export {login, logout};
