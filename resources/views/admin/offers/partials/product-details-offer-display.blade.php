 <div class="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0 mb-6">
     <!-- Author -->
     <div class="flex items-center sm:mr-4">

         <a class="block text-xl font-semibold text-slate-800 whitespace-nowrap" href="#0">
             {{ $productData->name? $productData->name:'' }}
         </a>
     </div>
     <!-- Right side -->
     <div class="flex flex-wrap items-center sm:justify-end space-x-4">
         <!-- Tag -->
         <div
             class="inline-flex items-center text-xs font-medium text-slate-100 bg-slate-900 bg-opacity-60 rounded-full text-center px-2 py-0.5" style="{{ $productData->discount ? 'display: show;' : 'display: none;' }}">
             <svg class="w-3 h-3 shrink-0 fill-current text-amber-500 mr-1" viewBox="0 0 12 12">
                 <path
                     d="M11.953 4.29a.5.5 0 00-.454-.292H6.14L6.984.62A.5.5 0 006.12.173l-6 7a.5.5 0 00.379.825h5.359l-.844 3.38a.5.5 0 00.864.445l6-7a.5.5 0 00.075-.534z" />
             </svg>
             {{ $productData->discount ? 'Special Discount' : '' }}
         </div>
         <!-- Rating -->
         <div class="flex items-center space-x-2 mr-2">
             <!-- Stars -->
             <div class="flex space-x-1">
                 <button>
                     <span class="sr-only">1 star</span>
                     <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                         <path
                             d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                     </svg>
                 </button>
                 <button>
                     <span class="sr-only">2 stars</span>
                     <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                         <path
                             d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                     </svg>
                 </button>
                 <button>
                     <span class="sr-only">3 stars</span>
                     <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                         <path
                             d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                     </svg>
                 </button>
                 <button>
                     <span class="sr-only">4 stars</span>
                     <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                         <path
                             d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                     </svg>
                 </button>
                 <button>
                     <span class="sr-only">5 stars</span>
                     <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                         <path
                             d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                     </svg>
                 </button>
             </div>
             <!-- Rate -->
             <div class="inline-flex text-sm font-medium text-amber-600">4.2</div>
         </div>
     </div>
 </div>
