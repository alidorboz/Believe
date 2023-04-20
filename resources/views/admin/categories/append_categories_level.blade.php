<div class="form-group">
    <label>Select Category Level</label>
    <select class="form-control select2" name="pid"id="pid"style="width: 100%;">
        <option value="0"@if (isset($categorydata['pid']) && $categorydata['pid']==0) selected="" @endif>Main Category</option>
         @if(!empty($getCategories))
            @foreach ($getCategories as $category )
                <option value="{{$category['id']}}"@if (isset($categorydata['pid']) && $categorydata['pid']==$category['id']) selected="" @endif>{{$category['categoryName']}}</option>
                @if(!empty($category['subcategories']))
                    @foreach ($category['subcategories'] as $subcategory )
                        <option value="{{$subcategory['id']}}">&nbsp;&raquo;&nbsp;{{$subcategory['categoryName']}}</option>     
                    @endforeach   
                @endif        
            @endforeach 
        @endif      
    </select>
</div>