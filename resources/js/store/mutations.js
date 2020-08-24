const mutations={
    auth:(state,payload)=>{
        state.authCheck = payload.status;
        state.auth = payload.auth;
    },
    selectedCompany:(state,payload)=>{
        state.exchangeRequest.selectedCompany=payload;
    },
    selectServices:(state,payload)=>{
        state.exchangeRequest.selectedServices=payload.services;
        state.exchangeRequest.totalAmount=payload.amount;
    }
};

export {mutations};
