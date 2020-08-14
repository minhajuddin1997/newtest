const updateProfile=(formData,config)=>{
    return new Promise((resolve, reject)=>{
       axios.put('/user/update',formData, config)
           .then(res=>res.data)
           .then((response)=>{
               if(response[0]==='success'){
                   resolve(response[1]);
               }
               else{
                   reject(response[1]);
               }
           })
           .catch((error)=>{
               reject(error);
           });
    });
};



const fetchAuthUser=(id, config)=>{
    return new Promise((resolve, reject)=>{
        axios.get(`/user/${id}`,config)
            .then(res=>res.data)
            .then((response)=>{
                resolve(response);
            }).catch((error)=>{
                reject(error)
            });
    });
}

export {updateProfile, fetchAuthUser};
