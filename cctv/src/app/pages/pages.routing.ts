import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';

/* Componentes */
import { PagesComponent } from './pages.component';


export const routes: Routes = [
    { path:'', component: PagesComponent},
];



@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class PagesRoutingModule {}