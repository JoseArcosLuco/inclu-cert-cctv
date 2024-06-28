import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { PagesComponent } from './pages/pages.component';
import { DashboardComponent } from './pages/dashboard/dashboard.component';

const routes: Routes = [
  {path:'', redirectTo:'login',pathMatch:'full'},
  {path:'login', component:LoginComponent},
  {path:'home', component:PagesComponent},
  {path:'dashboard', component:DashboardComponent},
  {path:'**', component: LoginComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
