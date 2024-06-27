import { Routes ,RouterModule} from '@angular/router';
import { NgModule } from '@angular/core';

export const routes: Routes = [
    { path:'login', loadChildren:()=>import('./login/login.module').then(m=>m.LoginModule) },
    { path:'admin', loadChildren:()=>import('./pages/pages.module').then(m=>m.PagesModule) },
    { path:'',redirectTo:'login',pathMatch:'full'}
    
];

@NgModule({
  declarations: [
    
  ],
  imports: [
    RouterModule.forRoot(routes),
    
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }