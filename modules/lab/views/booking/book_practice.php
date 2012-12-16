{{ streams:form stream="bookings" mode="new" return="lab/student" exclude="booking_date|booking_time" }}

{{ form_open }}

<table>

    {{ fields }}
    {{ if input_slug == "practice" }}

    <tr class="{{ odd_even }}">
        <td width="250">{{ input_title }}{{ required }} <small>{{ instructions }}</small></td>
        <td>{{ error }}
            <select name="practice" id="practice">
                <?php foreach ($practices['entries'] as $practice):?>
                <?php if(in_array($practice['id'], $practices_booked)):?>
                    <option value="<?php echo $practice['id']?>">
                        <?php echo $practice['subject']['subject_name'];?> - <?php echo $practice['practice_title'];?>
                    </option>
                        <?php endif;?>
                <?php endforeach;?>
            </select>
        </td>
    </tr>

    {{ else }}

    <tr class="{{ odd_even }}">
        <td width="250">{{ input_title }}{{ required }} <small>{{ instructions }}</small></td>
        <td>{{ error }}{{ input }}</td>
    </tr>

    {{ endif }}

    {{ /fields }}

</table>


<input type="hidden" name="booking_date" value="<?php echo $booking_date;?>"/>
{{ form_submit }}

{{ form_close }}

{{ /streams:form }}