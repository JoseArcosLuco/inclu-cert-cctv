import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';

/* Componentes */
import { PagesComponent } from './pages.component';
import { DashboardComponent } from './dashboard/dashboard.component';

const routes: Routes = [
    {
        path: 'admin',
        component: PagesComponent,
        //canActivate: [AuthGuard], /* implementar guards para proteger las rutas */
        children: [
            { path: '', component: DashboardComponent, data: { breadcrumb: 'Dashboard' } },
            { path: 'dashboard', component: DashboardComponent, data: { breadcrumb: 'Dashboard' } }
        ]
    }
];

@NgModule({
    imports: [
        RouterModule.forChild(routes)
    ],
    exports: [RouterModule]
})
export class PagesRoutingModule {}