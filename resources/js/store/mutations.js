const mutations={
    auth:(state,payload)=>{
        state.authCheck = payload.status;
        state.auth = payload.auth;
    },
    selectedCompany:(state,payload)=>{
        state.exchangeRequest.selectedCompany=payload;
    },
    receiveRequests:(state,payload)=>{
        state.exchangeRequest.receiveRequests=payload;
    },
    sendRequests:(state,payload)=>{
        state.exchangeRequest.sendRequests=payload;
    }
};

export {mutations};
