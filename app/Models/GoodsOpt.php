<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\OptMst;

class GoodsOpt extends Model
{
    //
    
    protected $table = 'goods_opt';
    
    public function getListOption($goodsJan, $flag = true)
    {
        $query = DB::table('goods_opt')
                ->select('opt_mst.*', 'goods_opt.goods_opt_order')
                ->join('opt_mst', function($join){
                    $join->on('goods_opt.goods_opt_packcode', '=', 'opt_mst.opt_packcode');
                    $join->on('goods_opt.goods_opt_code', '=', 'opt_mst.opt_code');
                });
        $query->where('goods_opt.goods_opt_jan', '=', $goodsJan);
        
        return $query->get();
    }
    
    /*
     * Get render list option
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @param  array $listOptMst
     * @return array
     * @Date 22/01/2016
     */
    public function renderListOption($listOptMst)
    {
        $idParent = [];
        $listOption = [];
        if ($listOptMst) {
            foreach ($listOptMst as $key => $value) {
                if (!in_array($value->opt_packcode, $idParent)) {
                        $idParent[] = $value->opt_code;
                        $listOption[$value->opt_packcode]['opt_packcode'] = $value->opt_packcode;
                        $listOption[$value->opt_packcode]['opt_packname'] = $value->opt_packname;
                        $listOption[$value->opt_packcode]['opt_packdesc'] = $value->opt_packdesc;
                        $listOption[$value->opt_packcode]['option_childrent'][$value->opt_code] = [
                            'opt_name' => $value->opt_name,
                            'opt_desc' => $value->opt_desc
                        ];
                } else {
                    foreach ($idParent as $key1 => $value1) {
                        if ($value->opt_packcode == $value1) {
                            $listOption[$value1]['option_childrent'][$value->opt_code] = [
                                'opt_name' => $value->opt_name,
                                'opt_desc' => $value->opt_desc
                            ];
                            $listOption[$value->opt_packcode]['option_childrent'][$value->opt_code]['opt_name'] = $value->opt_name;
                            $listOption[$value->opt_packcode]['option_childrent'][$value->opt_code]['opt_order'] = $value->goods_opt_order;
                        }
                    }
                } 
            }
        }
        
        //render option special
        // in the case of all of the options are the special option (opt_packcode == '000')
        // to split into two categories: there opt_flag opt_flag = 0 and = 1
        $listOptSpecial = OptMst::listOptSpecial();
        if (count($listOption) == 1 && array_key_exists('000', $listOption)) {
            if ($listOption['000']['option_childrent']) {
                foreach ($listOption['000']['option_childrent'] as $key => $value) {
                    // separate group of special options into clusters
                    // group option can pack = "000" but not particularly heading into a cluster
                    if (in_array($key, $listOptSpecial)) {
                        $listOption['special']['opt_packcode'] = '000';
                        $listOption['special']['opt_packname'] = '';
                        $listOption['special']['option_childrent'][$key] = $value;
                        unset($listOption['000']['option_childrent'][$key]);
                    }
                }
            }
        } else {
            // if the list of options including normal packages and special packages are converting packages pack = "000" into the special package
            if (array_key_exists('000', $listOption)) {
                $listOption['special'] = $listOption['000'];
                unset($listOption['000']);
            }
        }
        return $listOption;
    }
    
    public function renderTextOption($goodsJan){
        $text = '';
        $listOptMst = $this->getListOption($goodsJan, true);
        $listOption = $this->renderListOption($listOptMst);
        if (count($listOption) > 0) {
            foreach ($listOption as $key => $value) {
                $text .= '';
                $text .= $value['opt_packname'] . '<br/>';
                if(!empty($value['option_childrent'])) {
                    foreach ($value['option_childrent'] as $child){
                        $text .= '&nbsp&nbsp&nbsp' . $child['opt_name'] . '<br/>';
                    }
                }
            }
        }
        return $text;
    }
}
