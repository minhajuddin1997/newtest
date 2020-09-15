const state={
        authCheck: false,
        auth:{},
        exchangeRequest:{
            selectedCompany:{},
            receiveRequests:[]
        },
        exchangeProcess:{
            sender:{},
            requestedServices:[],
            offerServices:[],
            amount:{},
            paidTo:0,
            paidBy:0
        }
};

export {state};
