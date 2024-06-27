import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ShareModule } from '../../share/share.module';
import { DashboardComponent } from './dashboard.component';
import { PagesModule } from '../pages.module';

export const routerConfig = [{
    path: 'dashboard',
    component: DashboardComponent   
}];

@NgModule({
    imports: [
        CommonModule,
        RouterModule.forChild(routerConfig),
        PagesModule,
        
    ],
    declarations: [DashboardComponent],
    
    exports: [
        DashboardComponent
    ],
})

export class DashboardModule {
}