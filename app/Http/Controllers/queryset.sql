select a.id, c.kelompok, a.nd_internet, a.nama, a.alamat, hp, cp_nama, hp cp_num, tagihan, speed, paket, los_cat, kcontact, d.* from cc_form a 
	left join cc_master b on a.nd_internet = b.nd_internet 
	left join cc_kelompok c on a.kelompok = c.id
	left join (
	select u.*, v.cp from (
		select s.*, t.paket_n from (
			select q.*, r.wb from  (
				select o.*, p.jml_pg from (
					select m.*, n.kebutuhan from (
						select k.*, l.pkb_pv from (
							select i.*, j.pb_pv from (
								select g.*, h.pv from (
									select e.*, pkb_ih from (
										select c.id_form, alasan_cabut, posisi_NT, pb_ih from (
											select a.*,b.posisi_NT
											from(
												select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') alasan_cabut from cc_jawaban 
												where voc = 1 and deleted_at is null
												group by id_form) a
											left join (
												select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') posisi_NT from cc_jawaban 
												where voc = 2 and deleted_at is null
												group by id_form ) b on a.id_form = b.id_form
											) c left join (
											select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') pb_ih from cc_jawaban 
											where voc = 3  and deleted_at is null
											group by id_form
										) d on c.id_form = d.id_form
									) e left join (
									select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') pkb_ih from cc_jawaban 
									where voc = 4 and deleted_at is null
									group by id_form
									) f on e.id_form = f.id_form
								) g left join (
								select id_form, string_agg(case when jawaban != 'Lain-lain' then provider else concat('Lain:',jawaban_lain) end, ' || ') pv from cc_jawaban a left join 
								cc_provider b on a.jawaban::integer = b.id
								where voc = 5  and a.deleted_at is null
								group by id_form
								) h on g.id_form = h.id_form
							) i left join (
							select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') pb_pv from cc_jawaban 
							where voc = 11  and deleted_at is null
							group by id_form
							) j on i.id_form = j.id_form
						) k left join (
						select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') pkb_pv from cc_jawaban 
						where voc = 12 and deleted_at is null
						group by id_form
						) l on k.id_form = l.id_form
					) m left join (
					select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') kebutuhan from cc_jawaban 
					where voc = 6 and deleted_at is null
					group by id_form
					) n on m.id_form = n.id_form
				) o left join (
				select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') jml_pg from cc_jawaban 
				where voc = 7 and deleted_at is null
				group by id_form
				) p on o.id_form = p.id_form
			) q left join (
			select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') wb from cc_jawaban 
			where voc = 8  and deleted_at is null
			group by id_form
			) r on q.id_form  = r.id_form
		) s left join (
		select id_form, string_agg(case when jawaban != 'Lain-lain' then concat(nama_paket,'-',speed,'-',harga_paket) else concat('Lain:',jawaban_lain) end, ' || ') paket_n from cc_jawaban a left join cc_jenis_paket b on a.jawaban::integer = b.id
		where voc = 9  and a.deleted_at is null
		group by id_form
		) t on s.id_form = t.id_form
	) u left join (
	select id_form, string_agg(case when jawaban != 'Lain-lain' then jawaban else concat('Lain:',jawaban_lain) end, ' || ') cp from cc_jawaban 
	where voc = 10  and deleted_at is null
	group by id_form
	) v on u.id_form = v.id_form
) d on a.id = d.id_form 
where a.deleted_at is null
