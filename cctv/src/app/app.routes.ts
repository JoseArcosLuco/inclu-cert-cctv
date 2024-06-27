import { Routes ,RouterModule} from '@angular/router';
import { NgModule } from '@angular/core';
import { ShareModule } from './share/share.module';
import { PagesModule } from './pages/pages.module';

export const routes: Routes = [
    { path:'login', loadChildren:()=>import('./login/login.module').then(m=>m.LoginModule) },
    { path:'administracion', loadChildren:()=>import('./pages/pages.module').then(m=>m.PagesModule) },
    { path:'',redirectTo:'login',pathMatch:'full'},
    
    
];

@NgModule({
  declarations: [
    
  ],
  imports: [
    RouterModule.forRoot(routes),
    PagesModule
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }