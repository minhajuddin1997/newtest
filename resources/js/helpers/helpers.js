import {login, logout, register} from  './api/auth';
import {updateProfile} from  './api/profile';
import {authorize, isNotAuthorize, adminMiddleware} from './auth/authorizeRoute';
import {authApiConfig} from './auth/authTokenConfig';
import {prefixRoutes, redirectedPaths} from './routes/routeHelpers';
import {prefixPath} from "./routes/routePrefixPath";

export {login, logout, register, updateProfile,
    authorize, isNotAuthorize, adminMiddleware,
    prefixRoutes, redirectedPaths, prefixPath,
    authApiConfig};
