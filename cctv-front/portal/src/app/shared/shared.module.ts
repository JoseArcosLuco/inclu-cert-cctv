import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedComponent } from './shared.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { MainSidebarComponent } from './main-sidebar/main-sidebar.component';



@NgModule({
  declarations: [
    SharedComponent,
    HeaderComponent,
    FooterComponent,
    MainSidebarComponent
  ],
  imports: [
    CommonModule
  ],
  exports:[SharedComponent]
})
export class SharedModule { }
