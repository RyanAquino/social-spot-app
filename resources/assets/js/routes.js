import home from './pages/home';
import register from './pages/register';
import signin from './pages/signin';
import userHome from './pages/userHome';
import profile from './pages/profile';


export default [
    {
        path:'/',
        component: home,
        name: 'home'
    },
    {
        path:'/register',
        component: register,
        name: 'register'
    },
    {
        path:'/login',
        component: signin,
        name: 'signin'
    },
    {
        path:'/home',
        component: userHome,
        name: 'userHome'
    },
    {
        path:'/profile',
        component: profile,
        name: 'profile'
    }
]