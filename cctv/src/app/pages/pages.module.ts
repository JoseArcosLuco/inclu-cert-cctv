import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PagesRoutingModule } from './pages.routing';
import { HeaderComponent } from '../share/header/header.component';
import { FooterComponent } from '../share/footer/footer.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { MainSidebarComponent } from '../share/main-sidebar/main-sidebar.component';


@NgModule({
    declarations: [],
    imports: [CommonModule,PagesRoutingModule],
    exports: [HeaderComponent,MainSidebarComponent,FooterComponent,DashboardComponent],
})

export class PagesModule {
}