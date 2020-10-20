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
            selectedServices:[],
            amount:{},
            paidTo:0,
            paidBy:0,
            requestId:0
        },
        works:{
            work:{},
            paymentId:0
        }
};

export {state};
