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

var routes=[
    {path: '/', component:Home, name:'home'},
    {path: '/about', component:About, name:'about'},
    {path: '/how-it-works', component:HowItWorks, name:'how-it-works'},
    {path: '/contact-us', component:ContactUs, name:'contact-us'},
    {path: '/login', component:Login, name:'login', beforeEnter:isNotAuthorize},
    {path: '/register', component:Register, name:'register', beforeEnter:isNotAuthorize},
    {path: '/admin', component:Dashboard, name:'admin', beforeEnter:authorize},
    {path: '/admin/vendors', component:Vendor, name:'admin.vendors', beforeEnter:adminMiddleware},
    {path: '/admin/profile', component:Profile, name:'admin.profile', beforeEnter:authorize},
    {path: '/admin/services', component:Services, name:'admin.services', beforeEnter:vendorMiddleware},
    {path: '/admin/on-going-work', component:OnGoing, name:'admin.on_going_work', beforeEnter:vendorMiddleware},
    {path: '/admin/on-going-work/:id/services', component:OnGoingServices, name:'admin.on_going_services', beforeEnter:vendorMiddleware},
    {path: '/admin/company-details', component:CompanyDetails, name:'admin.company-details', beforeEnter:vendorMiddleware},
    {path: '/admin/category', component:Category, name:'admin.categories', beforeEnter:adminMiddleware}
];

routes=prefixRoutes(routes,prefixPath);

export default routes;
