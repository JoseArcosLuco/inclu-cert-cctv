import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PagesComponent } from './pages.component';
import { SharedModule } from '../shared/shared.module';
import { PagesRoutingModule } from './pages-routing.module';






@NgModule({
  declarations: [
    PagesComponent,
    
  ],
  imports: [
    CommonModule,
    SharedModule,
    PagesRoutingModule
  ],
  exports: [
    PagesComponent,
    
  ]
})
export class PagesModule { }
