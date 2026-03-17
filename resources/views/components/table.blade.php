<div class="w-full bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    {{ $thead }}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                {{ $tbody }}
            </tbody>
        </table>
    </div>
    
    @if(isset($footer))
        <div class="px-6 py-4 bg-slate-50/30 border-t border-slate-50">
            {{ $footer }}
        </div>
    @endif
</div>