
// function lazyLoad(view){
//     return() => import(`@/components/${view}.vue`)
// }

// import LoginComp from './components/Login/LoginComp.vue'
import LandingPage from './components/LandingPage.vue'
import StudentApp from './components/StudentApp.vue'
import TeacherApp from './components/TeacherApp.vue'
import AdminApp from './components/AdminApp.vue'
import StDashboard from './components/Student/StDashboard.vue'

export const routes = [
    { path: '/', name:'home', component:LandingPage },
    { path: '/login', name:'login', component:LandingPage },
    { path: '/student', name:'student', component:StudentApp },
    { path: '/teacher', name:'teacher', component:TeacherApp },
    { path: '/admin', name:'admin', component:AdminApp },
    { path: '/dashboard', name:'dashboard', component:StDashboard },
]
