   <div class="container">

       <!-- First Table -->
       <div class="table">
           <div class="header">الوارد</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $total_orders ?? 0 }}</div> <!-- Merged cells horizontally -->
           </div>
           <div class="row">
               <div class="cell">نقدي</div>
               <div class="cell">غير نقدي</div>
           </div>
           <div class="row">
               <div class="cell" rowspan="2">{{ $cash ?? 0 }}</div>
               <div class="cell" rowspan="2">{{ $cheque ?? 0 }}</div>
           </div>
           <div class="header">تسديدات التجار</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $traderPayment ?? 0 }}</div> <!-- Merged cells horizontally -->
           </div>
           <div class="row">
               <div class="cell">نقدي</div>
               <div class="cell">غير نقدي</div>
           </div>
           <div class="row">
               <div class="cell" rowspan="2">{{ $traderCash ?? 0 }}</div>
               <div class="cell" rowspan="2">{{ $traderCheque ?? 0 }}</div>
           </div>
       </div>

       <div class="table" style="height:265px;">
           <div class="header">المصروفات الإدارية</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $expenses ?? 0 }}</div>
           </div>
           <div class="header">مصروفات المناديب</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $fees ?? 0 }}</div>
           </div>
           <div class="header">مصروفات البنزين</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $solar ?? 0 }}</div>
           </div>
       </div>

       <!-- Fourth Table -->
       <div class="table">
           <div class="header">الرصيد السابق</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $total_previous ?? 0 }}</div>
           </div>
           <div class="row">
               <div class="cell">نقدي</div>
               <div class="cell">غير نقدي</div>
           </div>
           <div class="row">
               <div class="cell">{{ $previous_cash }}</div>
               <div class="cell">{{ $previous_cheque }}</div>
           </div>
           <div class="header">رصيد الخزنة لفترة</div>
           <div class="row total-row">
               <div class="cell" colspan="2">{{ $total_orders - ($traderPayment + $expenses + $fees + $solar) }}</div>
               <!-- Merged cells horizontally -->
           </div>
           <div class="row">
               <div class="cell">نقدي</div>
               <div class="cell">غير نقدي</div>
           </div>
           <div class="row">
               <div class="cell">{{ $cash - ($traderCash + $fees + $expenses + $solar) }}</div>
               <div class="cell">{{ $cheque - $traderCheque }}</div>
           </div>
       </div>
       <div class="table" style="height:170px;">
           <div class="header">اجمالي الرصيد النهائي للخزنة</div>
           <div class="row total-row">
               <div class="cell" colspan="2">
                   {{ $total_orders + $total_previous - ($traderPayment + $expenses + $fees + $solar) }}</div>
               <!-- Merged cells horizontally -->
           </div>
           <div class="row">
               <div class="cell">نقدي</div>
               <div class="cell">غير نقدي</div>
           </div>
           <div class="row">
               <div class="cell" rowspan="2">{{ $cash - ($traderCash + $expenses + $solar) + $previous_cash }}
               </div>
               <div class="cell" rowspan="2">{{ $cheque - $traderCheque + $previous_cheque }}</div>
           </div>
       </div>

   </div>
