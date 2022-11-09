
// function lazyLoad(view){
//     return() => import(`@/components/${view}.vue`)
// }

// import LoginComp from './components/Login/LoginComp.vue'
import LandingPage from './components/LandingPage.vue'
import StudentApp from './components/StudentApp.vue'
import TeacherApp from './components/TeacherApp.vue'
import AdminApp from './components/AdminApp.vue'
import StDashboard from './components/Student/StDashboard.vue'
import StLandingPage from './components/Student/StLandingPage.vue'
import TcLandingPage from './components/Teacher/TcLandingPage.vue'

export const routes = [
    { path: '/', name:'home', component: LandingPage },
    { path: '/login', name:'login', component: LandingPage },
    { path: '/student', name:'student', component: StudentApp, children:[
        { path: '/', name:'student_getstarted', component: StLandingPage },
        { path: 'dashboard', name:'student_dashboard', component: StDashboard },
    ] },
    { path: '/teacher', name:'teacher', component: TeacherApp, children:[
        { path: '/', name:'teacher_getstarted', component: TcLandingPage },
    ] },
    { path: '/admin', name:'admin', component: AdminApp },
]
