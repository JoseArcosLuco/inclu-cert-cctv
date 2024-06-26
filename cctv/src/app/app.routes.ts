import { Routes ,RouterModule} from '@angular/router';
import  {LoginComponent} from './share/login/login.component';
import { NgModule } from '@angular/core';

export const routes: Routes = [
    { path:'login', component: LoginComponent, data: { breadcrumb:'Login' } },
];

import { PagesRoutingModule } from './pages/pages.routing';



@NgModule({
  declarations: [
    
  ],
  imports: [
    RouterModule.forRoot(routes),
    PagesRoutingModule,
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }