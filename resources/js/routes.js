
// function lazyLoad(view){
//     return() => import(`@/components/${view}.vue`)
// }


import LandingPage from './components/LandingPage.vue'

import StudentApp from './components/StudentApp.vue'
import StLandingPage from './components/Student/StLandingPage.vue'
import StDashboard from './components/Student/StDashboard.vue'
import StHome from './components/Student/StHome.vue'
import StProfile from './components/Student/StProfile.vue'
import StAbsences from './components/Student/StAbsences.vue'
import StModules from './components/Student/StModules.vue'
import JustifyForm from './components/Student/AbsencesComps/JustifyForm.vue'



import TeacherApp from './components/TeacherApp.vue'
import TcLandingPage from './components/Teacher/TcLandingPage.vue'
import TcDashboard from './components/Teacher/TcDashboard.vue'
import TcHome from './components/Teacher/TcHome.vue'
import TcProfile from './components/Teacher/TcProfile.vue'
import TcAbsences from './components/Teacher/TcAbsences.vue'



import AdminApp from './components/AdminApp.vue'
import AdLandingPage from './components/Admin/AdLandingPage.vue'
import AdDashboard from './components/Admin/AdDashboard.vue'
import AdHome from './components/Admin/AdHome.vue'
import AdProfile from './components/Admin/AdProfile.vue'
import AdTeachersList from './components/Admin/AdTeachersList.vue'
import AdStudentsList from './components/Admin/AdStudentsList.vue'
import AdAbsences from './components/Admin/AdAbsences.vue'
import AdModulesList from './components/Admin/AdModulesList.vue'



export const routes = [
    { path: '/', name:'home', component: LandingPage },
    { path: '/login', name:'login', component: LandingPage },

    { path: '/student=:id', component: StudentApp, children:[
        { path: '/', name:'StGetstarted', component: StLandingPage },
        { path: 'dashboard', name:'StDashboard', component: StDashboard, children:[
            { path: 'home', name:'StHome', component: StHome },
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
            { path: 'profile', name:'TcProfile', component: TcProfile },
            { path: 'absences', name:'TcAbsences', component: TcAbsences },
        ] },
    ] },
    { path: '/admin=:id', name:'admin', component: AdminApp, children:[
        { path: '/', name:'AdGetstarted', component: AdLandingPage },
        { path: 'dashboard', name:'AdDashboard', component: AdDashboard, children:[
            { path: 'home', name:'AdHome', component: AdHome },
            { path: 'profile', name:'AdProfile', component: AdProfile },
            { path: 'teachers', name:'AdTeachersList', component: AdTeachersList },
            { path: 'students', name:'AdStudentsList', component: AdStudentsList},
            { path: 'absences', name:'AdAbsences', component: AdAbsences},
            { path: 'modules', name:'AdModulesList', component: AdModulesList },
        ] },
    ]}
]
