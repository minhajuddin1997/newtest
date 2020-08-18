import {login, logout, register} from  './api/auth';
import {updateProfile, fetchAuthUser} from  './api/profile';
import {authorize, isNotAuthorize, adminMiddleware, vendorMiddleware} from './auth/authorizeRoute';
import {authApiConfig} from './auth/authTokenConfig';
import {prefixRoutes, redirectedPaths} from './routes/routeHelpers';
import {prefixPath} from "./routes/routePrefixPath";

export {login, logout, register, updateProfile,
    authorize, isNotAuthorize, adminMiddleware,
    vendorMiddleware, prefixRoutes, redirectedPaths, prefixPath,
    authApiConfig, fetchAuthUser};
