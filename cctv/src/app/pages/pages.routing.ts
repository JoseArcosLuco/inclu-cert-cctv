import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';

/* Componentes */
import { PagesComponent } from './pages.component';
import { DashboardComponent } from './dashboard/dashboard.component';



export const routes: Routes = [
    
    { path:'administracion', 
        component: PagesComponent,
        children: [
            { path: '', component: DashboardComponent, data: { breadcrumb: 'Dashboard' } },
            { path: 'dashboard', component: DashboardComponent, loadChildren: () => import('./dashboard/dashboard.module').then(m => m.DashboardModule) },
        ]
    },
    
    

];

@NgModule({
    imports: [
        RouterModule.forChild(routes),
    ],
    exports: [RouterModule]
})
export class PagesRoutingModule {}