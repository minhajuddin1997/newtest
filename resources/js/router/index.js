import Home from '../pages/Home';
import About from '../pages/About';
import HowItWorks from '../pages/HowItWorks';
import ContactUs from '../pages/ContactUs';
import Login from '../pages/Login';
import Register from '../pages/Register';
import Dashboard from "../pages/admin/Dashboard";
import Profile from '../pages/admin/Profile';
import Vendor from "../pages/admin/Vendor";
import Services from "../pages/admin/Services";
import {authorize, isNotAuthorize, adminMiddleware, prefixRoutes, vendorMiddleware} from '../helpers/helpers';
import {prefixPath} from "../helpers/helpers";
import Category from "../pages/admin/Category";
import CompanyDetails from "../pages/admin/CompanyDetails";
import OnGoing from "../pages/admin/OnGoing/OnGoing";
import OnGoingServices from "../pages/admin/OnGoing/OnGoingServices";
import Messages from "../pages/admin/Messages";
import Connections from "../pages/admin/Connections";
import Requests from "../pages/admin/Requests";
import Receive from "../pages/admin/Request/Receive";
import Send from "../pages/admin/Request/Send";
import ExchangeDetails from "../pages/admin/Request/ExchangeDetails";
import Agreement from "../pages/admin/Request/Agreement";
import Payment from "../pages/admin/shared/Payment";
import WorkHistory from "../pages/admin/WorkHistory";
import PaymentsHistory from "../pages/admin/PaymentsHistory";
import Tasks from "../pages/admin/OnGoing/WorkDetails/Tasks";
import Files from "../pages/admin/OnGoing/WorkDetails/Files";
import PaymentDetails from "../pages/admin/Payment/PaymentDetails";
import AuthenticateLogin  from "../pages/AuthenticateLogin";
import CompanyProfile from "../pages/admin/CompanyProfile";
import NewConnection from "../pages/admin/NewConnection";

var routes=[
    {path: '/', component:Home, name:'home'},
    {path: '/about', component:About, name:'about'},
    {path: '/how-it-works', component:HowItWorks, name:'how-it-works'},

    {path: '/admin/company_profile', component:CompanyProfile, name:'admin.company_profile', beforeEnter:authorize},

    {path: '/contact-us', component:ContactUs, name:'contact-us'},
    {path: '/login', component:Login, name:'login', beforeEnter:isNotAuthorize},
    {path: '/register', component:Register, name:'register', beforeEnter:isNotAuthorize},
    {path: '/authenticate_login', component:AuthenticateLogin, name:'authenticate_login', beforeEnter:isNotAuthorize},

    {path: '/admin', component:Dashboard, name:'admin', beforeEnter:authorize},
    {path: '/admin/vendors', component:Vendor, name:'admin.vendors', beforeEnter:adminMiddleware},
    {path: '/admin/profile', component:Profile, name:'admin.profile', beforeEnter:authorize},
    {path: '/admin/services', component:Services, name:'admin.services', beforeEnter:vendorMiddleware},
    {path: '/admin/on-going-work', component:OnGoing, name:'admin.on_going_work', beforeEnter:vendorMiddleware},
    {path: '/admin/on-going-work/:id/services', component:OnGoingServices, name:'admin.on_going_services', beforeEnter:vendorMiddleware},
    {path: '/admin/service/details/:id/tasks', name:"admin.work-service.tasks", component:Tasks, beforeEnter:vendorMiddleware},


    {path: '/admin/service/details/:id/files', name:"admin.work-service.files", component:Files, beforeEnter:vendorMiddleware},
    {path: '/admin/company-details', component:CompanyDetails, name:'admin.company-details', beforeEnter:vendorMiddleware},
    {path: '/admin/category', component:Category, name:'admin.categories', beforeEnter:adminMiddleware},
    {path: '/admin/messages', component:Messages, name:'admin.messages', beforeEnter:vendorMiddleware},
    {path: '/admin/connections', component:Connections, name:'admin.connections', beforeEnter:vendorMiddleware},
    {path: '/admin/requests', component:Requests, name:'admin.requests', children:[
            {
                path:'',
                name:'receive',
                component:Receive
            },
            {
                path:'send',
                name:'send',
                component:Send
            }

        ], beforeEnter:vendorMiddleware},
    {path: '/admin/request/exchange/:id', component:ExchangeDetails, name:'admin.request.exchange', beforeEnter:vendorMiddleware},
    {path: '/admin/exchange/agreement', component:Agreement, name:'admin.exchange.agreement', beforeEnter:vendorMiddleware},
    {path: '/admin/verify/payment/:paymentId?', component:Payment, name:"admin.payment", beforeEnter:vendorMiddleware},
    {path: '/admin/work_history', component:WorkHistory, name:'admin.works_history', beforeEnter:vendorMiddleware},
    {path: '/admin/payments', component:PaymentsHistory, name:'admin.payments_history',
        // children:[
        //     {
        //         path:'',
        //         name:'received',
        //         component:Receive
        //     },
        //     {
        //         path:'paid',
        //         name:'paid',
        //         component:Send
        //     }
        //
        // ],
        beforeEnter:vendorMiddleware},
    {path: '/admin/payments/:id', component:PaymentDetails, name:'admin.payment_details', beforeEnter:vendorMiddleware},
    {path: '/admin/payments/del_payment/:id', component:PaymentsHistory, name:'admin.payment_del', beforeEnter:vendorMiddleware},
    {path: '/admin/works/del_work/:id', component:WorkHistory, name:'admin.del_work', beforeEnter:vendorMiddleware},
    {path: '/admin/new_connection', component:NewConnection, name:'admin.new_connection', beforeEnter:vendorMiddleware},

];

routes=prefixRoutes(routes,prefixPath);

export default routes;
