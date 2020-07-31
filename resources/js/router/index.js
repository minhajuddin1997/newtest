import Home from '../pages/Home';
import About from '../pages/About';
import HowItWorks from '../pages/HowItWorks';
import ContactUs from '../pages/ContactUs';
import Login from '../pages/Login';
import Register from '../pages/Register';
import Dashboard from "../pages/admin/Dashboard";
import Vendor from "../pages/admin/Vendor";
import {authorize, isNotAuthorize, adminMiddleware, prefixRoutes} from '../helpers/helpers';
import {prefixPath} from "../helpers/helpers";

var routes=[
    {path: '/', component:Home, name:'home'},
    {path: '/about', component:About, name:'about'},
    {path: '/how-it-works', component:HowItWorks, name:'how-it-works'},
    {path: '/contact-us', component:ContactUs, name:'contact-us'},
    {path: '/login', component:Login, name:'login', beforeEnter:isNotAuthorize},
    {path: '/register', component:Register, name:'register', beforeEnter:isNotAuthorize},
    {path:'/admin', component:Dashboard, name:'admin', beforeEnter:authorize},
    {path:'/admin/vendors', component:Vendor, name:'admin.vendors', beforeEnter:adminMiddleware}
];

routes=prefixRoutes(routes,prefixPath);

export default routes;
