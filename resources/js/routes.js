
// function lazyLoad(view){
//     return() => import(`@/components/${view}.vue`)
// }


import LandingPage from './components/LandingPage.vue'

import StudentApp from './components/StudentApp.vue'
import StLandingPage from './components/Student/StLandingPage.vue'
import StDashboard from './components/Student/StDashboard.vue'
import StHome from './components/Student/StHome.vue'
import StNotifications from './components/Student/StNotifications.vue'
import StProfile from './components/Student/StProfile.vue'
import StAbsences from './components/Student/StAbsences.vue'
import StModules from './components/Student/StModules.vue'
// import AbsencesList from './components/Student/AbsencesComps/AbsencesList.vue'
import JustifyForm from './components/Student/AbsencesComps/JustifyForm.vue'



import TeacherApp from './components/TeacherApp.vue'
import TcLandingPage from './components/Teacher/TcLandingPage.vue'
import TcDashboard from './components/Teacher/TcDashboard.vue'
import TcHome from './components/Teacher/TcHome.vue'
import TcNotifications from './components/Teacher/TcNotifications.vue'
import TcProfile from './components/Teacher/TcProfile.vue'
import TcAbsences from './components/Teacher/TcAbsences.vue'



import AdminApp from './components/AdminApp.vue'

export const routes = [
    { path: '/', name:'home', component: LandingPage },
    { path: '/login', name:'login', component: LandingPage },

    { path: '/student=:id', component: StudentApp, children:[
        { path: '/', name:'StGetstarted', component: StLandingPage },
        { path: 'dashboard', name:'StDashboard', component: StDashboard, children:[
            { path: 'home', name:'StHome', component: StHome },
            { path: 'notifications', name:'StNotifications', component: StNotifications },
            { path: 'profile', name:'StProfile', component: StProfile },
            { path: 'absences', name:'StAbsences', component: StAbsences, children:[
                { path: 'num=:absNum', name:'Justify', component: JustifyForm},
            ] },
            { path: 'modules', name:'StModules', component: StModules },
        ] },
    ] },

    { path: '/teacher=:id', component: TeacherApp, children:[
        { path: '/', name:'TcGetstarted', component: TcLandingPage },
        { path: 'dashboard', name:'TcDashboard', component: TcDashboard, children:[
            { path: 'home', name:'TcHome', component: TcHome },
            { path: 'notifications', name:'TcNotifications', component: TcNotifications },
            { path: 'profile', name:'TcProfile', component: TcProfile },
            { path: 'absences', name:'TcAbsences', component: TcAbsences },
        ] },
    ] },
    { path: '/admin=:id', name:'admin', component: AdminApp },
]
