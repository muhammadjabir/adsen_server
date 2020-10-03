export default  {
    path: '/',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: 'student-courses',
            name: 'student.courses.index',
            component:()=>import('../views/student-menu/Courses.vue'),
          
        },
        {
            path:'student-courses/video/:slug',
            name:'student.courses.video',
            component:()=>import('../views/student-menu/video.vue')
        },
       
        {
            path:'dashboard-student',
            name:'student.dashboard',
            component:()=>import('../views/student-menu/Dahsboard.vue')
        },
    ]
}
