import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { LoginComponent } from './login.component';


export const routes: Routes = [
    { path:'', component: LoginComponent }
];

@NgModule({
  declarations: [
    
  ],
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class LoginRoutingModule { }