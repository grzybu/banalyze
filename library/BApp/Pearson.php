<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 26.09.12
 * Time: 11:21
 * To change this template use File | Settings | File Templates.
 */
class BApp_Pearson
{
    public function countPearsonCorrelationCoefficient($X, $Y)
    {
        if(count($X) !== count($Y) or count($X)*count($Y)==0) throw new Exception("Niezgodna wielkość prób, lub próba o zerowej liczebności    ");

        //wielkość próby
        $n = count($X);


        //obliczanie średnich dla X i Y
        $x_ = (1/$n) * array_sum($X);
        $y_ = (1/$n) * array_sum($Y);

        $array = array();
        $sum_xi = 0;
        $sum_yi = 0;
        $sum_xiyi =0;
        $sum_xi2 = 0;
        $sum_yi2 = 0;

        for($i=0; $i<$n; $i++)
        {
            $sum_xi += $X[$i];
            $sum_yi += $Y[$i];
            $sum_xiyi += $X[$i]*$Y[$i];
            $sum_xi2 += pow($X[$i],2);
            $sum_yi2 += pow($Y[$i],2);

        }

       return ((1/$n) * $sum_xiyi - $x_*$y_)
                    / sqrt((1/$n * $sum_xi2 - pow($x_,2))*(1/$n * $sum_yi2- pow($y_,2) ));





    }
}
